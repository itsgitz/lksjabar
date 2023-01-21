import { Stack, StackProps } from 'aws-cdk-lib';
import { Construct } from 'constructs';
import { DomainConstruct } from './constructs/domain-construct';
import { EC2Construct } from './constructs/ec2-construct';
import { RdsServerlessConstruct } from './constructs/rds-serverless-construct';
import { EfsConstruct } from './constructs/efs-construct';

export class AwsCdkLksJabar2022Module3Stack extends Stack {
  constructor(scope: Construct, id: string, props?: StackProps) {
    super(scope, id, props);

    const domainConstruct = new DomainConstruct(this, 'Domain');
    const ec2Construct = new EC2Construct(this, 'EC2');
    const efsConstruct = new EfsConstruct(this, 'EFS', {
      vpc: ec2Construct.vpc
    });
    const rdsConstruct = new RdsServerlessConstruct(this, 'RDSServerless', {
      vpc: ec2Construct.vpc
    });
  }
}
