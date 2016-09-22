node {
    stage('Preparation') {
        env.PATH = "${tool 'Ant'}/bin:${env.PATH}"

        //download the git repository
        git 'https://github.com/Seretos/visualSelenium'

        //download and execute composer
        sh 'wget http://getcomposer.org/composer.phar'
        sh 'php composer.phar update --no-dev'
    }
    stage('Validation'){
        //execute apache ant build bot
        sh 'ant'
    }
    stage('Results'){
        junit 'build/logs/junit.xml'
        phploc 'build/logs/phploc.xml'
    }
}