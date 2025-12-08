<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<title>Crear Juez - Panel Admin</title>
	<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
	<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
	<style>
		.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24 }
	</style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200">
<div class="flex h-screen">
	@include('admin._sidebar')

	<main class="flex-1 p-8 overflow-y-auto">
		<div class="max-w-4xl mx-auto">
			<div class="mb-6 flex items-center justify-between">
				<div>
					<h1 class="text-3xl font-bold">Crear Juez</h1>
					<p class="text-sm text-gray-500">Registra un nuevo juez para asignaciones de revisión.</p>
				</div>
				<a href="{{ route('admin.jueces') }}" class="text-primary hover:underline">Volver a Jueces</a>
			</div>

			<div class="bg-white rounded-lg shadow-sm p-6">
				<form action="{{ route('admin.jueces.store') }}" method="POST">
					@csrf
					<div class="grid grid-cols-1 gap-4">
						<div>
							<label class="block text-sm font-medium mb-1">Nombre</label>
							<input type="text" name="nombre" class="w-full rounded border px-3 py-2" required>
						</div>
						<div>
							<label class="block text-sm font-medium mb-1">Apellido paterno</label>
							<input type="text" name="apellido_paterno" class="w-full rounded border px-3 py-2">
						</div>
						<div>
							<label class="block text-sm font-medium mb-1">Apellido materno</label>
							<input type="text" name="apellido_materno" class="w-full rounded border px-3 py-2">
						</div>
						<div>
							<label class="block text-sm font-medium mb-1">Correo electrónico</label>
							<input type="email" name="correo" class="w-full rounded border px-3 py-2" required placeholder="correo@dominio.com">
							@error('correo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
						</div>
						<div>
							<p class="text-sm text-gray-500">Se enviarán al correo indicado las credenciales (se generará una contraseña aleatoria).</p>
						</div>
						<div class="flex justify-end">
							<button class="bg-primary text-white px-4 py-2 rounded">Crear juez</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</main>
</div>
</body>
</html>
