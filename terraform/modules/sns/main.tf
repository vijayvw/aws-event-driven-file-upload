resource "aws_sns_topic" "this" {
  name = "${var.project_name}-topic"
}

resource "aws_sns_topic_subscription" "email" {
  topic_arn = aws_sns_topic.this.arn
  protocol  = "email"
  endpoint  = var.notification_email

  # Wait longer for manual confirmation
  confirmation_timeout_in_minutes = 30
}
