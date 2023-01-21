import { Construct } from 'constructs';
import {
  aws_ec2 as ec2,
  aws_rds as rds,
  aws_secretsmanager as secretmanager
} from 'aws-cdk-lib';
import * as cdk from 'aws-cdk-lib';

interface RdsServerlessProps {
  vpc: ec2.Vpc
}

export class RdsServerlessConstruct extends Construct {
  constructor(scope: Construct, id: string, props: RdsServerlessProps) {
    super(scope, id);

    const vpc = props.vpc;

    const cluster = new rds.ServerlessCluster(this, 'AuroraServerless', {
      engine: rds.DatabaseClusterEngine.AURORA_POSTGRESQL,
      vpc,
      enableDataApi: true,
      defaultDatabaseName: 'lksjabardb',
      credentials: { username: 'jabaradmin' },
      parameterGroup: rds.ParameterGroup.fromParameterGroupName(this, 'ParameterGroup', 'default.aurora-postgresql10'),
      removalPolicy: cdk.RemovalPolicy.DESTROY,
      vpcSubnets: vpc.selectSubnets({ subnetType: ec2.SubnetType.PRIVATE_ISOLATED })
    });

    cluster.asSecretAttachmentTarget();
  }
}
