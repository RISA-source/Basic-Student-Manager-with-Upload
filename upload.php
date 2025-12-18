<?php
require_once 'header.php';
require_once 'functions.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_FILES['portfolio']) || $_FILES['portfolio']['error'] === UPLOAD_ERR_NO_FILE) {
            throw new Exception("Please select a file to upload");
        }
        
        $fileName = uploadPortfolioFile($_FILES['portfolio']);
        
        $message = "File uploaded successfully as: " . htmlspecialchars($fileName);
        $messageType = 'success';
        
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = 'error';
    }
}
?>

<h1>Upload Portfolio File</h1>

<?php if ($message): ?>
    <div class="message <?php echo $messageType; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="portfolio">Select Portfolio File (PDF, JPG, PNG - Max 2MB):</label>
        <input type="file" id="portfolio" name="portfolio" accept=".pdf,.jpg,.jpeg,.png" required>
    </div>
    
    <button type="submit">Upload File</button>
</form>

<?php
require_once 'footer.php';
?>