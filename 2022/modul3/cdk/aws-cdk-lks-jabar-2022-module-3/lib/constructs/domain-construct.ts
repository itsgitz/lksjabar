import { Construct } from 'constructs';
import {
  aws_route53 as route53,
  aws_certificatemanager as acm
} from 'aws-cdk-lib';

export class DomainConstruct extends Construct {
  constructor(scope: Construct, id: string) {
    super(scope, id);

    const domainName: string = 'livia.my.id';
    const wildCardDomain: string = `*.${domainName}`;

    const zone = new route53.PublicHostedZone(this, 'Zone', {
      zoneName: domainName
    });

    const certificate = new acm.Certificate(this, 'Certificate', {
      domainName: wildCardDomain,
      validation: acm.CertificateValidation.fromDns(zone)
    });

    const rootCertificate = new acm.Certificate(this, 'RootCertificate', {
      domainName: domainName,
      validation: acm.CertificateValidation.fromDns(zone)
    });
  }
}
