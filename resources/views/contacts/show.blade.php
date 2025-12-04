<!DOCTYPE html>
<html>
<head>
    <title>View Contact</title>
</head>
<body>
    <h1>Contact Details</h1>

    <a href="{{ route('contacts.index') }}">← Back</a>

    <br><br>

    <p><strong>ID:</strong> {{ $contact->id }}</p>
    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Phone:</strong> {{ $contact->phone }}</p>
    <p><strong>Created at:</strong> {{ $contact->created_at }}</p>

    <br>

    <a href="{{ route('contacts.edit', $contact) }}">Edit</a>

    <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Delete this contact?')">
            Delete
        </button>
    </form>
</body>
</html>
