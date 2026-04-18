{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="title">
        Dashboard — Student Management Portal
    </x-slot>

    <x-slot name="header">
        <div class="bg-gradient-to-r from-green-600 via-emerald-500 to-teal-600 px-6 py-8 rounded-lg shadow-lg">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">Student Enrollment Records</h2>
                    <p class="text-white/80 text-sm mt-1">Manage and track all student enrollments efficiently</p>
                </div>
            </div>
        </div>
    </x-slot>

  <div class="py-8 px-6"
    x-data="{
      showAdd: false, showEdit: false,
      showDelete: false, showLogout: false,
      selected: { id:null, student_id:'', name:'',
                  course:'', year:'', block:'' },
      openEdit(e)   { this.selected = {...e}; this.showEdit = true; },
      openDelete(e) { this.selected = {...e}; this.showDelete = true; }
    }">

    @if (session('success'))
      <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 p-5 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-600 text-green-800 rounded-lg font-medium flex items-center justify-between shadow-lg">
        <div class="flex items-center gap-3">
          <div class="animate-bounce">
            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <p class="font-bold text-green-900">✓ Success!</p>
            <p class="text-sm text-green-700">{{ session('success') }}</p>
          </div>
        </div>
        <button @click="show = false" class="text-green-600 hover:text-green-800 transition-colors">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    @endif

    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Total Enrollees Card -->
      <div class="md:col-span-2 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6 shadow-md">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-blue-600">Total Enrollees</p>
            <p class="text-4xl font-bold text-blue-900 mt-2">{{ $enrollees->count() }}</p>
            <p class="text-xs text-blue-500 mt-1">Active students</p>
          </div>
          <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-4 rounded-lg">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <!-- Add Enrollee Card -->
      <div class="bg-gradient-to-br from-green-50 to-emerald-100 border border-green-200 rounded-xl p-6 shadow-md flex items-center justify-center">
        <button @click="showAdd = true"
          class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 shadow-lg transform hover:scale-105 flex items-center justify-center gap-2">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          <span>Add Enrollee</span>
        </button>
      </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
      <table class="min-w-full text-sm">
        <thead class="bg-gradient-to-r from-green-700 via-emerald-600 to-teal-600 text-white">
          <tr>
            @foreach(['Student ID','Name','Course','Year','Block','Actions'] as $col)
              <th class="px-4 py-4 text-left font-semibold">{{ $col }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse ($enrollees as $i => $e)
          <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-colors {{ $i%2===0?'bg-white':'bg-gray-50' }}">
            <td class="px-4 py-4 font-semibold text-gray-900">{{ $e->student_id }}</td>
            <td class="px-4 py-4 text-gray-700">{{ $e->name }}</td>
            <td class="px-4 py-4">
              <span class="inline-block bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">{{ $e->course }}</span>
            </td>
            <td class="px-4 py-4">
              <span class="inline-block bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">Year {{ $e->year }}</span>
            </td>
            <td class="px-4 py-4">
              <span class="inline-block bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 px-3 py-1 rounded-full text-xs font-semibold">{{ $e->block }}</span>
            </td>
            <td class="px-4 py-4">
              <div class="flex gap-2">
                <button
                  @click="openEdit({ id:{{ $e->id }}, student_id:'{{ $e->student_id }}',
                    name:'{{ $e->name }}', course:'{{ $e->course }}',
                    year:'{{ $e->year }}', block:'{{ $e->block }}' })"
                  class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-3 py-1 rounded text-xs font-semibold transition-all shadow-sm">Edit
                </button>
                <button
                  @click="openDelete({ id:{{ $e->id }}, student_id:'{{ $e->student_id }}',
                    name:'{{ $e->name }}' })"
                  class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-3 py-1 rounded text-xs font-semibold transition-all shadow-sm">Delete
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="px-4 py-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-gray-400 font-medium">No enrollees found</p>
            <p class="text-gray-500 text-sm mt-1">Click "Add Enrollee" above to get started.</p>
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div x-show="showAdd" x-transition style="display:none"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-5 pb-4 border-b-2 border-gradient-to-r from-green-500 to-emerald-500 bg-gradient-to-r from-green-50 to-emerald-50 -mx-6 px-6 pt-4 -mt-6 rounded-t-xl">
          <h3 class="text-lg font-bold bg-gradient-to-r from-green-700 to-emerald-700 bg-clip-text text-transparent">Add New Enrollee</h3>
          <button @click="showAdd=false" class="text-gray-400 hover:text-gray-600 text-2xl transition">&times;</button>
        </div>
        
        @if ($errors->any())
          <div class="mb-5 p-4 bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-lg">
            <div class="flex items-start gap-3">
              <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
              <div class="flex-1">
                <p class="font-bold text-red-800">⚠️ Cannot Add Student</p>
                <ul class="mt-2 space-y-1">
                  @foreach ($errors->all() as $error)
                    <li class="text-sm text-red-700">• {{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        @endif
        <form method="POST" action="{{ route('enrollees.store') }}">
          @csrf
          {{-- Student ID --}}
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Student ID <span class="text-red-500">*</span></label>
            <input type="text" name="student_id" maxlength="6"
              placeholder="e.g. 230001 (6 digits)"
              class="w-full border border-green-200 rounded-lg p-2 text-sm
                @error('student_id') border-red-500 @enderror" />
            @error('student_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          {{-- Name --}}
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Full Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" placeholder="e.g. Maria Santos"
              class="w-full border border-green-200 rounded-lg p-2 text-sm
                @error('name') border-red-500 @enderror" />
            @error('name')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          {{-- Course --}}
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Course <span class="text-red-500">*</span></label>
            <select name="course"
              class="w-full border border-green-200 rounded-lg p-2 text-sm">
              <option value="">-- Select Course --</option>
              @foreach(['BSIT','BSCS','BSCS-EMC DAT','BSEMC-GD'] as $course)
                <option value="{{ $course }}">{{ $course }}</option>
              @endforeach
            </select>
            @error('course')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          {{-- Year --}}
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Year Level <span class="text-red-500">*</span></label>
            <select name="year"
              class="w-full border border-green-200 rounded-lg p-2 text-sm">
              <option value="">-- Select Year --</option>
              @foreach([1,2,3,4] as $yr)
                <option value="{{ $yr }}">Year {{ $yr }}</option>
              @endforeach
            </select>
            @error('year')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          {{-- Block --}}
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Block <span class="text-red-500">*</span></label>
            <div class="flex gap-2">
              <select name="block_select"
                class="flex-1 border border-green-200 rounded-lg p-2 text-sm">
                <option value="">-- A, B, C, D --</option>
                @foreach(['A','B','C','D'] as $blk)
                  <option value="{{ $blk }}">{{ $blk }}</option>
                @endforeach
              </select>
              <input type="text" name="block" placeholder="Custom (A-Z)"
                @input="$event.target.value = $event.target.value.replace(/[^A-Z]/g,'').slice(0,5)"
                maxlength="5"
                class="flex-1 border border-green-200 rounded-lg p-2 text-sm" />
            </div>
            <small class="text-gray-400">Dropdown OR custom block (capital letters only).</small>
            @error('block')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end gap-3 mt-6">
            <button type="button" @click="showAdd=false"
              class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition">
              Cancel</button>
            <button type="submit"
              class="px-4 py-2 bg-gradient-to-r from-green-700 to-emerald-600 hover:from-green-800 hover:to-emerald-700 text-white rounded-lg font-semibold transition-all shadow-md">
              Add Enrollee</button>
          </div>
        </form>
      </div>
    </div>

    {{-- ── EDIT MODAL ─────────────────────────────────────────── --}}
    <div x-show="showEdit" x-transition style="display:none"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-5 pb-4 border-b-2 border-blue-400 bg-gradient-to-r from-blue-50 to-indigo-50 -mx-6 px-6 pt-4 -mt-6 rounded-t-xl">
          <h3 class="text-lg font-bold bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent">
            Edit Enrollee
          </h3>
          <button @click="showEdit=false" class="text-gray-400 hover:text-gray-600 text-2xl transition">&times;</button>
        </div>
        <form method="POST" :action="`/enrollees/${selected.id}`">
          @csrf @method('PUT')
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">Student ID</label>
            <p class="bg-gray-100 p-2 rounded text-sm" x-text="selected.student_id"></p>
            <small class="text-gray-400">Student ID cannot be changed.</small>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Full Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" x-model="selected.name"
              class="w-full border border-green-200 rounded-lg p-2 text-sm" />
            @error('name')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Course <span class="text-red-500">*</span></label>
            <select name="course" x-model="selected.course"
              class="w-full border border-green-200 rounded-lg p-2 text-sm">
              <option value="">-- Select Course --</option>
              @foreach(['BSIT','BSCS','BSCS-EMC DAT','BSEMC-GD'] as $course)
                <option value="{{ $course }}">{{ $course }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Year Level <span class="text-red-500">*</span></label>
            <select name="year" x-model="selected.year"
              class="w-full border border-green-200 rounded-lg p-2 text-sm">
              <option value="">-- Select Year --</option>
              @foreach([1,2,3,4] as $yr)
                <option value="{{ $yr }}">Year {{ $yr }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-bold mb-1">
              Block <span class="text-red-500">*</span></label>
            <div class="flex gap-2">
              <select name="block_select" x-model="selected.block"
                class="flex-1 border border-green-200 rounded-lg p-2 text-sm">
                <option value="">-- A, B, C, D --</option>
                @foreach(['A','B','C','D'] as $blk)
                  <option value="{{ $blk }}">{{ $blk }}</option>
                @endforeach
              </select>
              <input type="text" name="block" x-model="selected.block"
                @input="selected.block = $event.target.value.replace(/[^A-Z]/g,'').slice(0,5)"
                placeholder="Custom (A-Z)" maxlength="5"
                class="flex-1 border border-green-200 rounded-lg p-2 text-sm" />
            </div>
          </div>
          <div class="flex justify-end gap-3 mt-6">
            <button type="button" @click="showEdit=false"
              class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition">
              Cancel</button>
            <button type="submit"
              class="px-4 py-2 bg-gradient-to-r from-blue-700 to-indigo-600 hover:from-blue-800 hover:to-indigo-700 text-white rounded-lg font-semibold transition-all shadow-md">
              Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    {{-- ── DELETE MODAL ───────────────────────────────────────── --}}
    <div x-show="showDelete" x-transition style="display:none"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 border-t-4 border-red-500">
        <div class="flex items-center gap-3 mb-4">
          <div class="bg-gradient-to-br from-red-100 to-red-200 p-3 rounded-lg">
            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900">Confirm Deletion</h3>
        </div>
        <p class="text-sm text-gray-700 mb-1">
          Are you sure you want to delete
          <strong x-text="selected.name"></strong>
          (<span x-text="selected.student_id"></span>)?
        </p>
        <p class="text-xs text-red-600 mb-5">This action cannot be undone.</p>
        <form method="POST" :action="`/enrollees/${selected.id}`">
          @csrf @method('DELETE')
          <div class="flex justify-end gap-3">
            <button type="button" @click="showDelete=false"
              class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition">
              Cancel</button>
            <button type="submit"
              class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg font-semibold transition-all shadow-md">
              Yes, Delete</button>
          </div>
        </form>
      </div>
    </div>

    {{-- ── LOGOUT MODAL ───────────────────────────────────────── --}}
    <div x-show="showLogout" x-transition style="display:none"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-green-900 mb-3">Confirm Logout</h3>
        <p class="text-sm text-gray-700 mb-5">
          Are you sure you want to logout? Your session will be ended.
        </p>
        <div class="flex justify-end gap-3">
          <button type="button" @click="showLogout=false"
            class="px-4 py-2 bg-gray-400 text-white rounded-lg font-semibold">
            Cancel</button>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
              class="px-4 py-2 bg-orange-800 text-white rounded-lg font-semibold
                hover:bg-orange-900">
              Yes, Logout</button>
          </form>
        </div>
      </div>
    </div>

  </div>{{-- end x-data --}}
</x-app-layout>
