<?php
require_once 'header.php';
require_once 'functions.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $skills = $_POST['skills'] ?? '';
        
        if (empty($name) || empty($email) || empty($skills)) {
            throw new Exception("All fields are required");
        }
        
        $name = formatName($name);
        
        if (!validateEmail($email)) {
            throw new Exception("Invalid email address");
        }
        
        $skills = cleanSkills($skills);
        $skillsArray = explode(',', $skills);
        $skillsArray = array_map('trim', $skillsArray);
        $skillsArray = array_filter($skillsArray);
        
        if (empty($skillsArray)) {
            throw new Exception("Please enter at least one skill");
        }
        
        saveStudent($name, $email, $skillsArray);
        
        $message = "Student added successfully!";
        $messageType = 'success';
        
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = 'error';
    }
}
?>

<h1>Add Student Info</h1>

<?php if ($message): ?>
    <div class="message <?php echo $messageType; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    
    <div class="form-group">
        <label for="skills">Skills (comma-separated):</label>
        <input type="text" id="skills" name="skills" placeholder="PHP, JavaScript, HTML" required>
    </div>
    
    <button type="submit">Add Student</button>
</form>

<?php
require_once 'footer.php';
?>