node {
    stage('Preparation') {
        //download the git repository
        git 'https://github.com/Seretos/visualSelenium'

        //execute apache ant build bot
        def ant = new AntBuilder()
        ant.echo('ant test');
    }
}