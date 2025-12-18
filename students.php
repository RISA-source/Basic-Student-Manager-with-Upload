<?php
require_once 'header.php';
?>

<h1>View Students</h1>

<?php
$students = [];

if (file_exists('students.txt')) {
    $lines = file('students.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        $parts = explode('|', $line);
        if (count($parts) === 3) {
            $skillsArray = explode(',', $parts[2]);
            $skillsArray = array_map('trim', $skillsArray);
            
            $students[] = [
                'name' => $parts[0],
                'email' => $parts[1],
                'skills' => $skillsArray
            ];
        }
    }
}
?>

<?php if (empty($students)): ?>
    <p>No students found. <a href="add_student.php">Add a student</a> to get started.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Skills</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                    <td>
                        <?php 
                        foreach ($student['skills'] as $skill) {
                            echo htmlspecialchars($skill) . '<br>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
require_once 'footer.php';
?>