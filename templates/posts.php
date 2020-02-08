<!DOCTYPE html>
<html>
<head>
	<title>Posts</title>
</head>
<body>
	<p>Tous les messages.</p>

	<?php foreach ($posts as $post): ?>
	<p>
		Id: <?=$post['id'] ?><br>
		Message: <?=$post['name'] ?>
	</p>
	<?php endforeach; ?>
</body>
</html>