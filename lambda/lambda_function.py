import json
import boto3
import os

s3 = boto3.client("s3")
sns = boto3.client("sns")

TOPIC_ARN = os.environ["SNS_TOPIC_ARN"]


def lambda_handler(event, context):

    for record in event["Records"]:

        bucket = record["s3"]["bucket"]["name"]
        key = record["s3"]["object"]["key"]

        metadata = s3.head_object(
            Bucket=bucket,
            Key=key
        )

        size = metadata["ContentLength"]

        sns.publish(
            TopicArn=TOPIC_ARN,
            Subject="New File Uploaded",
            Message=f"""
A new file has been uploaded.

Bucket : {bucket}

File : {key}

Size : {size} bytes
"""
        )

    return {
        "statusCode": 200,
        "body": json.dumps("Success")
    }
