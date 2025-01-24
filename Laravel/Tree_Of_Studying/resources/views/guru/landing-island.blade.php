<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Landing Page Guru</title>
	<link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
	<script type="importmap">
		{
    "imports": {
        "three": "https://unpkg.com/three@latest/build/three.module.js",
        "three/addons/": "https://unpkg.com/three@latest/examples/jsm/"
    }
}
</script>

</head>

<body id="body_3D">
	<script  type="module" src="{{ asset('js/three-island.js') }}" defer></script>
</body>

</html>