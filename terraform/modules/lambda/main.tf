#Package Lambda
data "archive_file" "lambda_zip" {

  type = "zip"

  source_file = "${path.root}/../lambda/lambda_function.py"

  output_path = "${path.root}/lambda.zip"

}

#Create Lambda
resource "aws_lambda_function" "this" {

  function_name = "${var.project_name}-lambda"

  role = var.lambda_role_arn

  runtime = "python3.12"

  handler = "lambda_function.lambda_handler"

  filename         = data.archive_file.lambda_zip.output_path
  source_code_hash = data.archive_file.lambda_zip.output_base64sha256

  timeout = 10

  environment {

    variables = {
      SNS_TOPIC_ARN = var.sns_topic_arn
    }

  }

}

#Permission for S3
resource "aws_lambda_permission" "allow_s3" {

  statement_id = "AllowS3Invoke"

  action = "lambda:InvokeFunction"

  function_name = aws_lambda_function.this.function_name

  principal = "s3.amazonaws.com"

  source_arn = "arn:aws:s3:::${var.bucket_name}"

}

#S3 Notification
resource "aws_s3_bucket_notification" "this" {

  bucket = var.bucket_name

  lambda_function {

    lambda_function_arn = aws_lambda_function.this.arn

    events = [
      "s3:ObjectCreated:*"
    ]

  }

  depends_on = [
    aws_lambda_permission.allow_s3
  ]

}
