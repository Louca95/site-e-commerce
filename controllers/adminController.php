<?php
session_start();

$baseUri = '/08_Site_boutique_base';

function handleRegister() {
  global $conn, $baseUri;
  $errors = [];
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
      $username = trim($_POST['username']);
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      if (empty($username)) {
          $errors[] = "Le nom d'utilisateur est requis.";
      }
      if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors[] = "Une adresse e-mail valide est requise.";
      }
      if (empty($password) || strlen($password) < 6) {
          $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
      }

      if (empty($errors)) {
          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          try {
              $query = "INSERT INTO admins (name_users, email, password) VALUES (:username, :email, :password)";
              $result = $conn->prepare($query);
              $result->bindParam(':username', $username);
              $result->bindParam(':email', $email);
              $result->bindParam(':password', $hashedPassword);
              if ($result->execute()) {
                  header("Location: " . $baseUri . "/admin/login");
                  exit();
              }
          } catch (PDOException $e) {
              $errors[] = "Erreur lors de l'inscription : " . $e->getMessage();
          }
      }
  }
  include __DIR__ . '/../views/admin/register.php';
}

function handleLogin() {
  global $conn, $baseUri;
  $errors = [];
  if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      if (empty($email)) {
          $errors[] = "L'email est requis.";
      }
      if (empty($password)) {
          $errors[] = "Le mot de passe est requis.";
      }

      try {
          $query = "SELECT * FROM admins WHERE email = :email";
          $stmt = $conn->prepare($query);
          $stmt->bindParam(':email', $email);
          $stmt->execute();
          $admin = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($admin && password_verify($password, $admin['password'])) {
              $_SESSION['admin'] = $admin['name_users'];
              header('Location: ' . $baseUri . '/admin/dashboard');
              exit();
          } else {
              $errors[] = "Email ou mot de passe incorrect.";
          }
      } catch (PDOException $e) {
          echo "Erreur lors de la connexion : " . $e->getMessage();
      }
  }
  include __DIR__ . '/../views/admin/login.php';
}


function dashboard() {
  global $conn, $baseUri;
  if (!isset($_SESSION['admin'])) {
      header("Location: " . $baseUri . "/admin/login");
      exit();
  }

  try {
      $query = "SELECT * FROM products";
      $stmt = $conn->query($query);
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      $errors[] = "Erreur lors de la récupération des produits: " . $e->getMessage();
  }

  include __DIR__ . '/../views/admin/dashboard.php';
}

function getOrders() {
  global $conn;
  try {
      $stmt = $conn->prepare("SELECT orders.id AS order_id, orders.client_name, orders.client_email, orders.total_price, orders.quantity, products.name AS product_name 
          FROM orders
          JOIN products ON orders.product_id = products.id
          ORDER BY orders.id, products.name");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
      return [];
  }
}

// Fonction pour afficher les commandes
function viewOrders() {
  // global $baseUri;
  $orders = getOrders();
  include __DIR__ . '/../views/admin/orders.php'; // Nouvelle vue pour les commandes
}

function logout() {
  global $baseUri;
  if (isset($_SESSION['admin'])) {
      unset($_SESSION['admin']);
      session_destroy();
  }
  header("Location: " . $baseUri);
  exit();
}


?>