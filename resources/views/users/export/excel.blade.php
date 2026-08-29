<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->nama }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
