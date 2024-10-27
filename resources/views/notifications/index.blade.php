@foreach ($notifications as $notification)
    <div class="notification">
        <p>Notification ID: {{ $notification->id }}</p> <!-- Displaying the notification ID -->
        <p>{{ $notification->data['message'] }}</p>
        <p>Progress: {{ $notification->data['progress'] }}%</p>
        <p>Status: {{ $notification->data['is_completed'] ? 'Completed' : 'In Progress' }}</p>
    </div>
@endforeach
