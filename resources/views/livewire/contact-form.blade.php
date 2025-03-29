<div>
    <h1>Nuevo mensaje de contacto</h1>
    <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Terminal:</strong> {{ $data['terminal'] ?? 'No especificada' }}</p>
    <p><strong>Mensaje:</strong> {{ $data['message'] }}</p>
</div>
