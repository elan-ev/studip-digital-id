# DigiCard - Digital Student ID

A Stud.IP plugin for providing a digital student ID card for Google Wallet and Apple Wallet.

## Description

DigiCard enables students to store and use their student ID card digitally in Google Wallet and Apple Wallet. The plugin integrates seamlessly into Stud.IP and provides an easy way to make the ID card available on smartphones.

## Features

- **Digital Student ID**: Generation of a digital student ID card with all relevant information
- **Google Wallet Integration**: Direct integration with Google Wallet for easy addition of the ID card
- **Apple Wallet Integration**: Direct integration with Apple Wallet for easy addition of the ID card
- **Automatic Data Transfer**: Uses existing Stud.IP data (name, matriculation number, study courses, semester)
- **Student Photo**: Integration of the student photo from Stud.IP
- **Validity Period**: Automatic display of the current semester period
- **Token-based Authentication**: Secure verification via API tokens

## Requirements

- Stud.IP Installation
- PHP >= 8.1
- Composer
- Google Cloud Project with enabled Google Wallet API
- Google Service Account Credentials
- Apple Developer Account
- Apple Wallet certificates

## Installation

1. Clone the plugin into the Stud.IP plugin directory:
```
git clone <repository-url> plugins/elan-ev/DigiCard
```

2. Install dependencies:
```
cd plugins/elan-ev/DigiCard
composer install
```

3. Configure Google Cloud credentials:
   - Copy `credentials/project.json.sample` to `credentials/project.json`
   - Enter your Google Service Account credentials

4. Activate the plugin in Stud.IP:
   - Log in to Stud.IP as administrator
   - Navigate to "Admin" → "System" → "Plugins"
   - Register and Activate the DigiCard plugin

5. Run database migrations:
   - Migrations will be executed automatically on first access
   - Alternatively, run manually via Stud.IP CLI

## Configuration

### Google Cloud Setup

1. Create a Google Cloud Project
2. Enable the Google Wallet API
3. Create a Service Account
4. Download the JSON credentials
5. Configure the Issuer ID in `credentials/project.json`

### Stud.IP Configuration

The plugin automatically adds a navigation item "Digital Student ID" to the profile menu.

## Usage

### For Students

1. Click on "Digital Student ID" in the Stud.IP profile
2. View the preview of the digital ID card
3. Click on "Add to Google Wallet"
4. ID card will be saved in Google Wallet

### For Administrators

The plugin provides an API for verifying student ID cards:

- Endpoint: `/digicard/index/verify/{token}`
- Method: GET
- Response: JSON with student data

## Database Structure

### Table: digicard_tokens

Stores the generated tokens for each user:

- `user_id`: Stud.IP User ID
- `token`: Unique token
- `mkdate`: Creation date
- `chdate`: Modification date

### Table: digicard_api_tokens

Stores API tokens for external verification:

- `id`: Primary key
- `token`: API token
- `description`: Token description
- `mkdate`: Creation date

## Project Structure

```
DigiCard.php                 # Main plugin class
bootstrap.php                # Bootstrap file
plugin.manifest              # Plugin manifest
composer.json                # Composer dependencies
app/
  controllers/
    index.php                # Main controller
  models/
    DigicardTokens.php       # Token management
    DigitalIdCard.php        # Google Wallet integration
    User.php                 # User data model
  views/
    index/
      index.php              # Main view
      verify.php             # Verification view
credentials/
  project.json.sample        # Sample configuration
migrations/
  001_add_tables.php         # Database migration
  002_add_api_token.php      # API token migration
```

## Security

- All tokens are stored encrypted
- API access only with valid token
- Student photos are only delivered via authenticated requests
- Google Service Account credentials should never be stored in the repository

## Authors

- **Till Glöggler** - [gloeggler@elan-ev.de](mailto:gloeggler@elan-ev.de)

## About ELAN e.V.

This library is developed and maintained by [elan e.V.](https://elan-ev.de) - a non-profit organization dedicated to advancing digital education and e-learning solutions.

## Copyright

Copyright © 2025 ELAN e.V.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

## Support

For issues, questions, or contributions, please contact elan e.V. or visit [https://elan-ev.de](https://elan-ev.de)