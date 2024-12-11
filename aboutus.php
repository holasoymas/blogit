<?php

require_once './backend/services/SessionManager.php';
require_once './backend/config/db.php';

session_start();
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === 'admin123';
$db = new Database();
$pdo = $db->connect();

// Handle the content update if the request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content']) && $isAdmin) {
  $newContent = $_POST['content'];

  $updateSql = "UPDATE about_us SET content = :content WHERE id = 1";
  $updateStmt = $pdo->prepare($updateSql);

  if ($updateStmt->execute(['content' => $newContent])) {
    $successMessage = "Content updated successfully!";
  } else {
    $errorMessage = "Error updating content.";
  }
}

// Fetch the current content
$sql = "SELECT content FROM about_us WHERE id = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$content = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>About us | Blogit</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      line-height: 1.6;
      color: #333;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .admin-panel {
      background: #f8f9fa;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      display: <?php echo $isAdmin ? 'block' : 'none'; ?>;
    }

    .edit-button,
    .save-button {
      padding: 8px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    .edit-button {
      background: #007bff;
      color: white;
    }

    .save-button {
      background: #28a745;
      color: white;
      display: none;
    }

    .message {
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .success {
      background: #d4edda;
      color: #155724;
    }

    .error {
      background: #f8d7da;
      color: #721c24;
    }
  </style>
</head>

<body>

  <?php if (!empty($successMessage)): ?>
    <div class="message success"><?php echo $successMessage; ?></div>
  <?php elseif (!empty($errorMessage)): ?>
    <div class="message error"><?php echo $errorMessage; ?></div>
  <?php endif; ?>

  <?php if ($isAdmin): ?>
    <div class="admin-panel">
      <button class="edit-button" onclick="toggleEdit()">Edit Content</button>
      <form method="POST" id="content-form" style="display: inline;">
        <button type="submit" class="save-button" onclick="prepareContent()">Save Changes</button>
      </form>
    </div>
  <?php endif; ?>

  <div id="editable-content" contenteditable="<?php echo $isAdmin ? 'false' : 'false'; ?>">
    <?php echo $content["content"]; ?>
  </div>

  <script>
    let isEditing = false;

    function toggleEdit() {
      const content = document.getElementById('editable-content');
      const saveButton = document.querySelector('.save-button');
      const editButton = document.querySelector('.edit-button');

      if (!isEditing) {
        content.contentEditable = 'true';
        content.focus();
        saveButton.style.display = 'inline-block';
        editButton.textContent = 'Cancel';
      } else {
        content.contentEditable = 'false';
        saveButton.style.display = 'none';
        editButton.textContent = 'Edit Content';
      }

      isEditing = !isEditing;
    }

    function prepareContent() {
      const content = document.getElementById('editable-content').innerHTML;
      const form = document.getElementById('content-form');

      // Create a hidden input to submit the content
      let hiddenInput = document.createElement('input');
      hiddenInput.type = 'hidden';
      hiddenInput.name = 'content';
      hiddenInput.value = content;

      form.appendChild(hiddenInput);
    }
  </script>

</body>

</html>
