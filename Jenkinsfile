node {
    stage('Dependencies') {
        build job: 'fileManager'
    }
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

        step([$class: 'hudson.plugins.checkstyle.CheckStylePublisher', pattern: '**/build/logs/checkstyle.xml'])
        step([$class: 'CloverPublisher', cloverReportDir: 'build/logs', cloverReportFileName: 'clover.xml'])
        publishHTML([allowMissing: false, alwaysLinkToLastBuild: true, keepAll: true, reportDir: 'build/coverage/', reportFiles: 'index.html', reportName: 'code coverage'])
        publishHTML([allowMissing: false, alwaysLinkToLastBuild: true, keepAll: true, reportDir: 'build/api/', reportFiles: 'index.html', reportName: 'phpdox'])
    }
}
