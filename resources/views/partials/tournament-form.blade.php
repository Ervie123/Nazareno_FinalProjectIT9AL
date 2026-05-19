@php $t = $tournament ?? []; @endphp

<div class="form-group">
  <label>Tournament Name</label>
  <input type="text" name="name" value="{{ $t['name'] ?? old('name') }}"
         placeholder="e.g. Spring Championship" required/>
</div>

<div class="form-group">
  <label>Sport</label>
  <select name="sport">
    @foreach(['Basketball','Soccer','Volleyball','Baseball','Tennis','Badminton','Swimming','Athletics'] as $sport)
      <option value="{{ $sport }}" {{ ($t['sport'] ?? '') === $sport ? 'selected' : '' }}>{{ $sport }}</option>
    @endforeach
  </select>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Start Date</label>
    <input type="date" name="startDate" value="{{ $t['startDate'] ?? old('startDate') }}"/>
  </div>
  <div class="form-group">
    <label>End Date</label>
    <input type="date" name="endDate" value="{{ $t['endDate'] ?? old('endDate') }}"/>
  </div>
</div>

<div class="form-group">
  <label>Status</label>
  <select name="status">
    <option value="upcoming" {{ ($t['status'] ?? '') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
    <option value="ongoing"  {{ ($t['status'] ?? '') === 'ongoing'  ? 'selected' : '' }}>Ongoing</option>
    <option value="completed"{{ ($t['status'] ?? '') === 'completed'? 'selected' : '' }}>Completed</option>
  </select>
</div>

<div class="form-row">
  <div class="form-group">
    <label>Number of Teams</label>
    <input type="number" name="teams" value="{{ $t['teams'] ?? 8 }}" min="2"/>
  </div>
  <div class="form-group">
    <label>Number of Matches</label>
    <input type="number" name="matches" value="{{ $t['matches'] ?? 0 }}" min="0"/>
  </div>
</div>
