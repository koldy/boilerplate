# Koldy Boilerplate - Starter Project

Use this project as starting project if you plan to use Koldy Framework and all benefits that Framework brings with itself.

## Development Environment

After cloning this project, run `init.sh` in console. `init.sh` will:

1. Start Vagrant virtual machine with Ubuntu 16.04
2. Install Nginx, PHP 7.1 and PostgreSQL 10
3. Initialize complete project structure, including folders that are under `.gitignore`
4. Install Composer and dependencies: Koldy Framework as main dependency, PHPUnit for testing and etc.

When script is done, open http://localhost:5000

Next time you'll want to start the project, use `start.sh` instead of `init.sh`.

Koldy Boilerplate Vagrant VM will take only **128MB** of RAM, together with complete OS, web server, database and
all other installed services. Not much, isn't it?


## Database

To access database directly, connect to PostgreSQL localhost:5102, username `vagrant`, password `vagrant`, database `vagrant`.

Boilerplate is already configured to talk to the local PostgreSQL.


## Testing

You can start unit tests from your computer by running `test.sh`. It'll run PHPUnit command on VM. If you want to start tests
on VM, then go to `/vagrant` folder and start `./bin/phpunit` command.


## Build

Build will usually depend on your frontend environment, but we're not here to solve frontend problems.

To build backend, extend `build.sh` with your own stuff. We've prepared only version increment as part of build process.


## Deployment

The `build-and-deploy.sh` script will:

1. Run `build.sh`
2. Create `deploy` folder as output folder
3. Run Composer install command with optimize autoloader flag
4. Copy all *production* files and folders to `deploy` folder, meaning you won't get tests, tools, storage and other non-production stuff
5. Run Composer install again, to return to original state

If you run `build-and-deploy.sh` script on the boilerplate, it'll produce `deploy` folder of about **1.5MB**. This is not mistake.
