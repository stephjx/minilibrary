<x-library-layout>
    <x-slot name="header">
        Edit Student
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6">
            <form action="{{ route('students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="student_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Student Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="student_number" id="student_number" value="{{ old('student_number', $student->student_number) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        @error('student_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $student->full_name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        @error('full_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="course" class="block text-sm font-medium text-gray-700 mb-2">
                            Course <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="course" id="course" value="{{ old('course', $student->course) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        @error('course')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year_level" class="block text-sm font-medium text-gray-700 mb-2">
                            Year Level <span class="text-red-500">*</span>
                        </label>
                        <select name="year_level" id="year_level" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                            <option value="">Select Year Level</option>
                            <option value="1st Year" {{ old('year_level', $student->year_level) == '1st Year' ? 'selected' : '' }}>1st Year</option>
                            <option value="2nd Year" {{ old('year_level', $student->year_level) == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                            <option value="3rd Year" {{ old('year_level', $student->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                            <option value="4th Year" {{ old('year_level', $student->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                            <option value="5th Year" {{ old('year_level', $student->year_level) == '5th Year' ? 'selected' : '' }}>5th Year</option>
                        </select>
                        @error('year_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('students.show', $student) }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                        Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-library-layout>
