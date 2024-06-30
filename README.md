# Laravel Backup Package

A Laravel package to backup your application database and files to a cloud storage.

## Installation

To install the package, use composer:

```bash
composer require tharindu/laravel-backup
```

## Configuration

Add the following environment variables to your `.env` file:

```env
GOOGLE_DRIVE_CLIENT_ID=your-google-drive-client-id
GOOGLE_DRIVE_CLIENT_SECRET=your-google-drive-client-secret
GOOGLE_DRIVE_REFRESH_TOKEN=your-google-drive-refresh-token
```

## Usage

To create a database backup and upload it to Google Drive, use the following artisan command:

```bash
php artisan make:backup
```

## Google Drive Integration

To obtain the necessary Google Drive credentials, follow these steps:

1. **Create a Google Cloud Project:**
   - Go to the [Google Cloud Console](https://console.cloud.google.com/).
   - Create a new project or select an existing project.

2. **Enable the Google Drive API:**
   - Navigate to the "API & Services" dashboard.
   - Enable the Google Drive API for your project.

3. **Create OAuth 2.0 Credentials:**
   - Go to "Credentials" and create OAuth 2.0 credentials.
   - Select "Web application" and configure the redirect URIs (e.g., http://localhost).
   - Save the credentials and note down the Client ID and Client Secret.

4. **Generate a Refresh Token:**
   - Use a tool like [OAuth 2.0 Playground](https://developers.google.com/oauthplayground/) to generate a refresh token.
   - Configure the OAuth 2.0 Playground to use your Client ID and Client Secret.
   - Authorize the Google Drive API and generate a refresh token.

5. **Add Credentials to `.env` File:**
   - Copy the Client ID, Client Secret, and Refresh Token into your `.env` file as shown above.
