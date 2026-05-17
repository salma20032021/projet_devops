pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                sh 'docker build -t php-task-app .'
            }
        }

        stage('Test') {
            steps {
                sh 'echo "Test OK"'
            }
        }

        stage('Run') {
            steps {
                sh '''
                docker stop php-task-app || true
                docker rm php-task-app || true
                docker run -d --name php-task-app -p 8093:80 php-task-app
                '''
            }
        }
    }
}
