## Installation steps

To run application, follow next steps:
1. Make sure you have git, docker и docker-compose installed.
2. Clone project from github repo: <code>git clone https://github.com/ViacheslavKurch/test_travellizy.git</code>
3. Build application with docker-compose: <code>docker-compose up -d</code>
4. Go inside docker container: <code>docker exec -it php-fpm bash</code>
5. Update composer to generate autoloader.php and add phpunit: <code>composer update</code>
6. Run script: <code>php console parseImages http://domain.example.com</code>
