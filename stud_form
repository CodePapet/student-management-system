@php $s = $student ?? null; @endphp
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="first_name">First name</label>
        <input id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $s?->first_name) }}" required>
        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="last_name">Last name</label>
        <input id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $s?->last_name) }}" required>
        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="student_number">Student number</label>
        <input id="student_number" name="student_number" class="form-control @error('student_number') is-invalid @enderror" value="{{ old('student_number', $s?->student_number) }}" required>
        @error('student_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $s?->email) }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="phone">Phone</label>
        <input id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $s?->phone) }}">
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label" for="programme">Programme</label>
        <input id="programme" name="programme" class="form-control @error('programme') is-invalid @enderror" value="{{ old('programme', $s?->programme ?? 'Bachelor of Business Computing') }}" required>
        @error('programme')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-2">
        <label class="form-label" for="year_of_study">Year</label>
        <select id="year_of_study" name="year_of_study" class="form-select @error('year_of_study') is-invalid @enderror">
            @for ($y = 1; $y <= 5; $y++)
                <option value="{{ $y }}" @selected(old('year_of_study', $s?->year_of_study ?? 1) == $y)>{{ $y }}</option>
            @endfor
        </select>
        @error('year_of_study')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mt-4 d-flex gap-2">
    <button class="btn btn-brand">Save student</button>
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
