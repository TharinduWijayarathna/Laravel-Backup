<?php

namespace Tharindu\LaravelBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql;

class BackupCommand extends Command
{
    protected $signature = 'make:backup';
    protected $description = 'Backup the database to Google Drive';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filename = 'backup-' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = storage_path('app/' . $filename);

        // Dump the database
        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile($filepath);

        // Upload to Google Drive
        $this->uploadToGoogleDrive($filepath, $filename);

        // Remove the local backup file
        unlink($filepath);

        $this->info('Backup created and uploaded to Google Drive successfully.');
    }

    protected function uploadToGoogleDrive($filepath, $filename)
    {
        // Configure the Google API Client
        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
        $client->addScope(\Google_Service_Drive::DRIVE_FILE);

        $service = new \Google_Service_Drive($client);

        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $filename
        ]);
        $content = file_get_contents($filepath);

        $file = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/sql',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return $file->id;
    }
}
