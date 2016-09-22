node {
    stage('Preparation') {
        env.PATH = "${tool 'Ant'}/bin:${env.PATH}"

        //download the git repository
        git 'https://github.com/Seretos/visualSelenium'

        //download and execute composer
        sh 'wget http://getcomposer.org/composer.phar'
        sh 'php composer.phar update --no-dev'

        //execute apache ant build bot
        //sh 'ant'
    }
}