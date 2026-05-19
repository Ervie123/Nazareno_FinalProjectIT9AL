@php
  $m = $match ?? [];
@endphp

<div class="form-row">
  <div class="form-group">
    <label>Team A</label>
    <input type="text" name="teamA"
           value="{{ old('teamA', $m['teamA'] ?? '') }}"
           placeholder="e.g. Philippines" required>
  </div>

  <div class="form-group">
    <label>Team B</label>
    <input type="text" name="teamB"
           value="{{ old('teamB', $m['teamB'] ?? '') }}"
           placeholder="e.g. Japan" required>
  </div>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Score A</label>
    <input type="number" name="scoreA"
           value="{{ old('scoreA', $m['scoreA'] ?? 0) }}" min="0">
  </div>

  <div class="form-group">
    <label>Score B</label>
    <input type="number" name="scoreB"
           value="{{ old('scoreB', $m['scoreB'] ?? 0) }}" min="0">
  </div>
</div>

<div class="form-group">
  <label>Tournament</label>
  <select name="tournament" required>
    <option value="">Select Tournament</option>
    @foreach($tournaments as $t)
      @php
        $value = is_object($t) ? $t->name : $t;
      @endphp
      <option value="{{ $value }}"
        {{ old('tournament', $m['tournament'] ?? '') == $value ? 'selected' : '' }}>
        {{ $value }}
      </option>
    @endforeach
  </select>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Date</label>
    <input type="date" name="date"
           value="{{ old('date', $m['date'] ?? '') }}">
  </div>

  <div class="form-group">
    <label>Time</label>
    <input type="time" name="time"
           value="{{ old('time', $m['time'] ?? '') }}">
  </div>
</div>

<div class="form-group">
  <label>Venue</label>
  <input type="text" name="venue"
         value="{{ old('venue', $m['venue'] ?? '') }}"
         placeholder="e.g. Rizal Memorial Stadium">
</div>

<div class="form-group">
  <label>Status</label>
  <select name="status">
    <option value="scheduled"
      {{ old('status', $m['status'] ?? '') == 'scheduled' ? 'selected' : '' }}>
      Scheduled
    </option>

    <option value="live"
      {{ old('status', $m['status'] ?? '') == 'live' ? 'selected' : '' }}>
      Live
    </option>

    <option value="completed"
      {{ old('status', $m['status'] ?? '') == 'completed' ? 'selected' : '' }}>
      Completed
    </option>
  </select>
</div>