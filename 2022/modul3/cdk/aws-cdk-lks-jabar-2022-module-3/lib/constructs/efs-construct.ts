import { Construct } from 'constructs';
import {
  aws_efs as efs,
  aws_ec2 as ec2
} from 'aws-cdk-lib';

interface EfsProps {
  vpc: ec2.Vpc
}

export class EfsConstruct extends Construct {
  constructor(scope: Construct, id: string, props: EfsProps) {
    super(scope, id);

    const vpc = props.vpc;

    const fs = new efs.FileSystem(this, 'FileSystem', {
      vpc: vpc,
      vpcSubnets: vpc.selectSubnets({ subnetType:ec2.SubnetType.PRIVATE_ISOLATED })
    });
  }
}
