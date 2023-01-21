import { Construct } from "constructs";
import { 
  aws_route53 as route53,
  aws_route53_targets as targets,
  aws_certificatemanager as acm
} from 'aws-cdk-lib';

export class DomainConstruct extends Construct {
  public readonly zone: route53.PublicHostedZone;
  public readonly certificate: acm.Certificate;
  public readonly domainName: string;

  constructor(scope: Construct, id: string) {
    super(scope, id);

    this.domainName = 'liviastudio.my.id';

    const apiDomainName: string = `api.${this.domainName}`;

    this.zone = new route53.PublicHostedZone(this, 'Domain', {
      zoneName: this.domainName,
    });

    this.certificate = new acm.Certificate(this, 'Certificate', {
      domainName: apiDomainName,
      validation: acm.CertificateValidation.fromDns(this.zone)
    }); 
  }
}
