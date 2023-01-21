import { Construct } from 'constructs';
import {
  aws_ec2 as ec2,
  aws_autoscaling as autoscaling
} from 'aws-cdk-lib';

export class EC2Construct extends Construct {
  public readonly vpc: ec2.Vpc;

  constructor(scope: Construct, id: string) {
    super(scope, id);

    const vpc: ec2.Vpc = new ec2.Vpc(this, 'VPC', {
      maxAzs: 3,
      cidr: '10.0.0.0/24',
      subnetConfiguration: [
        {
          name: 'lks-jabar-module-3-public',
          subnetType: ec2.SubnetType.PUBLIC,
          cidrMask: 28,
        },
        {
          name: 'lks-jabar-module-3-private',
          subnetType: ec2.SubnetType.PRIVATE_WITH_NAT,
          cidrMask: 28
        },
        {
          name: 'lks-jabar-module-3-isolated',
          subnetType: ec2.SubnetType.PRIVATE_ISOLATED,
          cidrMask: 28
        }
      ],
    });

    const privateSg = new ec2.SecurityGroup(this, 'PrivateSecurityGroup', {
      vpc,
      description: 'Allow ssh and database access from private network',
      allowAllOutbound: true,
    });

    const publicSg = new ec2.SecurityGroup(this, 'PublicSecurityGroup', {
      vpc,
      description: 'Allow ssh and database access from public network',
      allowAllOutbound: true,
    });


    privateSg.addIngressRule(ec2.Peer.anyIpv4(), ec2.Port.tcp(22), 'Allow ssh from inside');
    privateSg.addIngressRule(ec2.Peer.anyIpv4(), ec2.Port.tcp(5432), 'Allow database PostgreSQL from inside');
    privateSg.addIngressRule(ec2.Peer.anyIpv4(), ec2.Port.tcp(6379), 'Allow incoming redis connection');

    publicSg.addIngressRule(ec2.Peer.anyIpv4(), ec2.Port.tcp(22), 'Allow ssh from outside');


    const keyName: string = 'lksjabar2022-modul3-us-west-1'; 

    const machineImage = ec2.MachineImage.latestAmazonLinux({
      generation: ec2.AmazonLinuxGeneration.AMAZON_LINUX_2,
    });

    const publicSubnets = vpc.selectSubnets({ subnetType: ec2.SubnetType.PUBLIC });
    const privateSubnets = vpc.selectSubnets({ subnetType: ec2.SubnetType.PRIVATE_WITH_NAT });

    new autoscaling.AutoScalingGroup(this, 'AutoScaling', {
      vpc,
      //instanceType: ec2.InstanceType.of(ec2.InstanceClass.BURSTABLE3, ec2.InstanceSize.MICRO),
      instanceType: new ec2.InstanceType('t3a.micro'),
      machineImage: machineImage,
      securityGroup: privateSg,
      keyName: keyName,
      minCapacity: 2,
      desiredCapacity: 2,
      maxCapacity: 4,
      vpcSubnets: privateSubnets,
    })  

    const bastion = new ec2.Instance(this, 'BastionHost', {
      vpc: vpc,
      securityGroup: publicSg,
      instanceName: 'LKSJabar2022-BastionHost',
      //instanceType: ec2.InstanceType.of(ec2.InstanceClass.BURSTABLE3, ec2.InstanceSize.MICRO),
      instanceType: new ec2.InstanceType('t3a.micro'),
      machineImage: machineImage,
      keyName: keyName,
      vpcSubnets: publicSubnets,
    })

    this.vpc = vpc;

  }
}
