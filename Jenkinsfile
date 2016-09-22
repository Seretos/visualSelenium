node {
    stage('Preparation') {
        env.PATH = "${tool 'Ant'}/bin:${env.PATH}"

        //download the git repository
        git 'https://github.com/Seretos/visualSelenium'

        sh 'wget http://getcomposer.org/composer.phar'

        //execute apache ant build bot
        //sh 'ant'
    }
}