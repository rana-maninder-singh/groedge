<?php
require_once 'auth.php';
require_admin();
$submissions = get_submissions();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions | GroEdge Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { padding: 20px; max-width: 1000px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
        .admin-header h1 { color: #1a365d; font-size: 1.5rem; }
        .admin-nav a { margin-left: 15px; color: #2c5282; text-decoration: none; }
        .admin-nav a:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #f7fafc; color: #1a365d; font-weight: 600; }
        tr:hover { background: #f8fafc; }
        .submission-detail { background: #f7fafc; padding: 20px; border-radius: 8px; margin-top: 15px; }
        .submission-detail h4 { color: #1a365d; margin-bottom: 10px; }
        .submission-detail p { margin: 8px 0; }
        .empty { color: #718096; padding: 40px; text-align: center; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; background: #e2e8f0; color: #4a5568; }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1>Contact Form Submissions</h1>
        <div class="admin-nav">
            <a href="settings.php">Site settings</a>
            <a href="services.php">Services</a>
            <a href="projects.php">Projects</a>
            <a href="logout.php">Log out</a>
            <a href="../index.html">View site</a>
        </div>
    </div>

    <p style="color:#4a5568; margin-bottom:20px;">Form data is saved in <strong>data/submissions.json</strong> and can be viewed here. Emails are also sent to the addresses set in Site settings.</p>

    <?php if (empty($submissions)): ?>
        <p class="empty">No submissions yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Industry</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $s): ?>
                <tr>
                    <td><?php echo htmlspecialchars($s['submitted_at'] ?? $s['id'] ?? '-' ); ?></td>
                    <td><?php echo htmlspecialchars($s['name'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($s['company'] ?? '-'); ?></td>
                    <td><a href="mailto:<?php echo htmlspecialchars($s['email'] ?? ''); ?>"><?php echo htmlspecialchars($s['email'] ?? ''); ?></a></td>
                    <td><?php echo htmlspecialchars($s['industry'] ?? '-'); ?></td>
                    <td>
                        <details>
                            <summary style="cursor:pointer; color:#2c5282;">View</summary>
                            <div class="submission-detail">
                                <h4><?php echo htmlspecialchars($s['name'] ?? ''); ?> — <?php echo htmlspecialchars($s['submitted_at'] ?? ''); ?></h4>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($s['phone'] ?? '-'); ?></p>
                                <p><strong>Company size:</strong> <?php echo htmlspecialchars($s['employees'] ?? '-'); ?></p>
                                <p><strong>Primary interest:</strong> <?php echo htmlspecialchars($s['service'] ?? '-'); ?></p>
                                <p><strong>Challenge:</strong><br><?php echo nl2br(htmlspecialchars($s['challenge'] ?? '-')); ?></p>
                                <?php if (!empty($s['message'])): ?>
                                <p><strong>Additional:</strong><br><?php echo nl2br(htmlspecialchars($s['message'])); ?></p>
                                <?php endif; ?>
                            </div>
                        </details>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
