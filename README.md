# Facebook Post Downloader
A command line tool for downloading posts from Facebook Pages into local storage.

## Installation
### 1. Install dependencies
```
composer install
```

### 2. Configure the application
Create `.env` from `.env.dist` in the root directory and provide all the configuration parameters.

*Note: Only MySQL or MariaDB database are supported.*

### 3. Create the database
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
``` 

## Usage
### Add some pages
```
php bin/console app:add-page o2cz
php bin/console app:add-page TMobileCZ
php bin/console app:add-page vodafoneCZ
```

### Download new posts
```
php bin/console app:download-new-posts
```

This command downloads new posts for all pages or last 200 posts if no posts were downloaded yet.

## Contributing
Always run `make checks` to make sure that your code adheres the coding standards and passes tests.
