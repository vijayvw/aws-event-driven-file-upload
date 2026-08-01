<?php
/* Premium AWS File Upload - Landing Page
 * Save as index.php
 * Backend form action remains upload.php
 */
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>AWS Event Driven File Upload</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="bg-grid"></div>
<div class="blob blob1"></div>
<div class="blob blob2"></div>
<div class="blob blob3"></div>
<div class="particles">

    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>

</div>

<header class="nav">
  <div class="logo">
    <img src="assets/aws/cloud.svg" alt="AWS">
    <span>UploadFlow</span>
</div>
  <nav>
    <a href="#features">Features</a>
    <a href="#pipeline">Pipeline</a>
    <a href="#upload">Upload</a>
  </nav>
</header>

<section class="hero">
  <div class="hero-text">
      <span class="badge">AWS • EC2 • S3 • Lambda • SNS</span>
      <h1>Event Driven File Upload Platform</h1>
      <p>
        Upload any supported file and watch your cloud pipeline automatically
        process it through Amazon S3, Lambda and SNS.
      </p>

      <div class="hero-buttons">
        <a href="#upload" class="primary-btn">Start Upload</a>
        <a href="#pipeline" class="secondary-btn">View Pipeline</a>
      </div>
       <div class="hero-stats">

    <div class="stat">
        <h2>100%</h2>
        <span>Secure Uploads</span>
    </div>

    <div class="stat">
        <h2>AWS</h2>
        <span>Cloud Powered</span>
    </div>

    <div class="stat">
        <h2>4</h2>
        <span>Integrated Services</span>
    </div>

</div>
  </div>

  <div class="cloud-card">
      <div class="cloud">
    <img src="assets/aws/cloud.svg" alt="Cloud">
</div>
      <div class="rings"></div>
  </div>
</section>

<section id="pipeline" class="pipeline">
<h2>Cloud Processing Pipeline</h2>

<div class="flow">

<div class="node">
<div class="icon">
    <img src="assets/aws/ec2.svg" alt="Amazon EC2">
</div>
<h3>EC2</h3>
<p>Apache + PHP</p>
</div>

<div class="arrow">➜</div>

<div class="node">
<div class="icon">
    <img src="assets/aws/s3.svg" alt="Amazon S3">
</div>
<h3>S3</h3>
<p>Storage</p>
</div>

<div class="arrow">➜</div>

<div class="node">
<div class="icon">
    <img src="assets/aws/lambda.svg" alt="AWS Lambda">
</div>
<h3>Lambda</h3>
<p>Event</p>
</div>

<div class="arrow">➜</div>

<div class="node">
<div class="icon">
    <img src="assets/aws/sns.svg" alt="Amazon SNS">
</div>
<h3>SNS</h3>
<p>Notify</p>
</div>

</div>
</section>

<section class="tech-stack">

    <h2>Built With</h2>

    <div class="tech-grid">

        <div class="tech-item">
            <img src="assets/aws/ec2.svg" alt="EC2">
            <span>Amazon EC2</span>
        </div>

        <div class="tech-item">
            <img src="assets/aws/s3.svg" alt="S3">
            <span>Amazon S3</span>
        </div>

        <div class="tech-item">
            <img src="assets/aws/lambda.svg" alt="Lambda">
            <span>AWS Lambda</span>
        </div>

        <div class="tech-item">
            <img src="assets/aws/sns.svg" alt="SNS">
            <span>Amazon SNS</span>
        </div>

        <div class="tech-item">
            <img src="assets/aws/php.svg" alt="PHP">
            <span>PHP</span>
        </div>

        <div class="tech-item">
            <img src="assets/aws/apache.svg" alt="Apache">
            <span>Apache</span>
        </div>

    </div>

</section>

<section id="upload" class="upload-section">


<div class="upload-card">

<h2>Upload File</h2>

<form action="upload.php" method="POST" enctype="multipart/form-data">

<label class="drop-area">

<input type="file" name="fileToUpload" required>

<div class="upload-icon">
    <img src="assets/aws/cloud.svg" alt="Cloud Upload">
</div>

<h3>Drag & Drop Files</h3>

<p>PNG • JPG • PDF • ZIP • TXT</p>

<span class="browse">Browse Files</span>

</label>

<div class="progress-container">

    <div class="progress-bar">

        <div class="progress-fill"></div>

    </div>

    <span class="progress-text">Ready to Upload</span>

</div>

<button class="upload-btn" type="submit">
Upload to Amazon S3
</button>

</form>

</div>

</section>

<section id="features" class="features">

<div class="feature">
<h3>Secure Upload</h3>
<p>IAM Roles with no hardcoded credentials.</p>
</div>

<div class="feature">
<h3>Serverless Processing</h3>
<p>Automatic Lambda execution after upload.</p>
</div>

<div class="feature">
<h3>Email Notification</h3>
<p>SNS instantly notifies after processing.</p>
</div>

</section>

<footer>
Built with ❤️ using AWS, Terraform, PHP and Amazon S3
</footer>

<script src="script.js"></script>
</body>
</html>
