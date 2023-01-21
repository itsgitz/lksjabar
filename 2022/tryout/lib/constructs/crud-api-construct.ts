import { Construct } from 'constructs';
import * as cdk from 'aws-cdk-lib';
import { 
  aws_dynamodb as dynamodb,
  aws_lambda as lambda,
  aws_apigateway as apigateway,
  aws_certificatemanager as acm,
  aws_route53 as route53,
  aws_route53_targets as targets
} from 'aws-cdk-lib';

interface CrudAPIProps {
  zone: route53.PublicHostedZone;
  certificate: acm.Certificate;
  domainName: string
}

export class CrudAPIConstruct extends Construct {
  constructor(scope: Construct, id: string, props: CrudAPIProps) {
    super(scope, id);

    // Create a dynamodb table
    const tableName: string = 'http-crud-tutorial-items';
    const table: dynamodb.Table = new dynamodb.Table(this, 'Table', {
      tableName: tableName,
      partitionKey: {
        name: 'id',
        type: dynamodb.AttributeType.STRING
      },
      billingMode: dynamodb.BillingMode.PAY_PER_REQUEST,
      removalPolicy: cdk.RemovalPolicy.DESTROY,
    });

    const apiDomainName: string = `api.${props.domainName}`;

    // Define a lambda function
    const functionName: string = 'MyHeroes';
    const handler: lambda.Function = new lambda.Function(this, 'Function', {
      functionName: functionName,
      runtime: lambda.Runtime.NODEJS_16_X,
      handler: 'heroes.handler',
      code: lambda.Code.fromAsset('resources'),
      timeout: cdk.Duration.minutes(3)
    });

    table.grantReadWriteData(handler);

    // Define an API Gateway
    const apiName: string = 'My Heroes API';
    const api: apigateway.RestApi = new apigateway.RestApi(this, 'API', {
      restApiName: apiName,
      description: 'Show my fav heroes!', 
      domainName: {
        domainName: apiDomainName,
        certificate: props.certificate
      }
    });

    const itemsResourceApi = api.root.addResource('items');

    // Integrate api with lambda
    const myHeroesApiIntegration = new apigateway.LambdaIntegration(handler, {
      requestTemplates: { 'application/json': '{ "statusCode": "200" }' }
    });

    itemsResourceApi.addMethod('GET', myHeroesApiIntegration);

    // Pointing our API Gateway to route53
    new route53.ARecord(this, 'APIGatewayAlias', {
      zone: props.zone,
      recordName: apiDomainName,
      target: route53.RecordTarget.fromAlias(new targets.ApiGateway(api))
    });
  }
}
