@php $t = $team ?? []; @endphp

<div class="form-group">
  <label>Team Name</label>
  <input type="text" name="name" value="{{ $t['name'] ?? old('name') }}"
         placeholder="e.g. Japan Womens Volleyball" required/>
</div>

<div class="form-group">
  <label>Number of Players</label>
  <input type="number" name="players" value="{{ $t['players'] ?? 0 }}" min="0"/>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Wins</label>
    <input type="number" name="wins" value="{{ $t['wins'] ?? 0 }}" min="0"/>
  </div>
  <div class="form-group">
    <label>Losses</label>
    <input type="number" name="losses" value="{{ $t['losses'] ?? 0 }}" min="0"/>
  </div>
</div>

<div class="form-group">
  <label>Points</label>
  <input type="number" name="points" value="{{ $t['points'] ?? 0 }}" min="0"/>
</div>
