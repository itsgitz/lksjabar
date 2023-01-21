import { Stack, StackProps } from 'aws-cdk-lib';
import { Construct } from 'constructs';
import { DomainConstruct } from './constructs/domain-construct';
import { CrudAPIConstruct } from './constructs/crud-api-construct';

export class TryoutStack extends Stack {
  constructor(scope: Construct, id: string, props?: StackProps) {
    super(scope, id, props);

    // Task 1. Create a public hosted 
    const domainConstruct = new DomainConstruct(this, 'TaskOne');

    // Task 2. Create CRUD API with Lambda dan DynamoDB: 
    const crudAPIConstruct = new CrudAPIConstruct(this, 'TaskTwo', {
      zone: domainConstruct.zone,
      certificate: domainConstruct.certificate,
      domainName: domainConstruct.domainName
    });
  }
}
