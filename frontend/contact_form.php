<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Contact Us - LBSport</title>
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body>
        <?php include 'includes/topbar.php'; ?>

        <main class="container my-5 pt-5">
            <h2 class="mb-4">Contact Us</h2>
            <p>If you have any questions, feedback, or inquiries, please fill out the form below. We'll get back to you as soon as possible!</p>

            <form action="../backend/controllers/contact.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control">
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </main>

        <?php include 'includes/footer.php'; ?>

        <script src="assets/libs/jQuery/jquery-3.7.1.min.js"></script>
        <script src="assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    </body>
</html>
