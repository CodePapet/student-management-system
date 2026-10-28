@php $c = $course ?? null; @endphp
<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label" for="code">Course code</label>
        <input id="code" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $c?->code) }}" required>
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-9">
        <label class="form-label" for="name">Course name</label>
        <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $c?->name) }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $c?->description) }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="credit_units">Credit units</label>
        <input id="credit_units" type="number" name="credit_units" class="form-control @error('credit_units') is-invalid @enderror" value="{{ old('credit_units', $c?->credit_units ?? 3) }}" required>
        @error('credit_units')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label" for="capacity">Capacity</label>
        <input id="capacity" type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', $c?->capacity ?? 60) }}" required>
        @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="lecturer_id">Lecturer</label>
        <select id="lecturer_id" name="lecturer_id" class="form-select @error('lecturer_id') is-invalid @enderror">
            <option value="">Not assigned</option>
            @foreach ($lecturers as $l)
                <option value="{{ $l->id }}" @selected(old('lecturer_id', $c?->lecturer_id) == $l->id)>{{ $l->name }}</option>
            @endforeach
        </select>
        @error('lecturer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-brand">Save course</button>
    <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
