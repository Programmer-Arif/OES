<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    @php
        $numId=1;  
    @endphp
    @foreach($students as $student)
        <tr>
            <td align="left">{{ $numId++}}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>