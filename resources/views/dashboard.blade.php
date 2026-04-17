{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="title">
        Dashboard — Student Management Portal
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student Enrollment Records
        </h2>
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
      <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    <div class="flex justify-between items-center mb-6">
      <h3 class="text-lg font-bold text-gray-700">
        Total Enrollees: {{ $enrollees->count() }}
      </h3>
      <button @click="showAdd = true"
        class="bg-green-800 text-white px-4 py-2 rounded-lg font-semibold
          hover:bg-green-900">
        + Add Enrollee
      </button>
    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow">
      <table class="min-w-full text-sm">
        <thead class="bg-green-900 text-white">
          <tr>
            @foreach(['Student ID','Name','Course','Year','Block','Actions'] as $col)
              <th class="px-4 py-3 text-left">{{ $col }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse ($enrollees as $i => $e)
          <tr class="{{ $i%2===0?'bg-white':'bg-green-50' }}">
            <td class="px-4 py-3">{{ $e->student_id }}</td>
            <td class="px-4 py-3">{{ $e->name }}</td>
            <td class="px-4 py-3">{{ $e->course }}</td>
            <td class="px-4 py-3">Year {{ $e->year }}</td>
            <td class="px-4 py-3">{{ $e->block }}</td>
            <td class="px-4 py-3">
              <div class="flex gap-2">
                <button
                  @click="openEdit({ id:{{ $e->id }}, student_id:'{{ $e->student_id }}',
                    name:'{{ $e->name }}', course:'{{ $e->course }}',
                    year:'{{ $e->year }}', block:'{{ $e->block }}' })"
                  class="bg-green-700 text-white px-3 py-1 rounded text-xs
                    font-semibold hover:bg-green-800">Edit
                </button>
                <button
                  @click="openDelete({ id:{{ $e->id }}, student_id:'{{ $e->student_id }}',
                    name:'{{ $e->name }}' })"
                  class="bg-orange-800 text-white px-3 py-1 rounded text-xs
                    font-semibold hover:bg-orange-900">Delete
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">
            No enrollees found. Click "Add Enrollee" to get started.
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div x-show="showAdd" x-transition style="display:none"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-5">
          <h3 class="text-lg font-bold text-green-900">Add New Enrollee</h3>
          <button @click="showAdd=false" class="text-gray-400 text-xl">&times;</button>
        </div>
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
              class="px-4 py-2 bg-gray-400 text-white rounded-lg font-semibold">
              Cancel</button>
            <button type="submit"
              class="px-4 py-2 bg-green-800 text-white rounded-lg font-semibold
                hover:bg-green-900">
              Add Enrollee</button>
          </div>
        </form>
      </div>
    </div>

    {{-- ── EDIT MODAL ─────────────────────────────────────────── --}}
    <div x-show="showEdit" x-transition style="display:none"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-5">
          <h3 class="text-lg font-bold text-green-900">
            Edit Enrollee — <span x-text="selected.student_id"></span>
          </h3>
          <button @click="showEdit=false" class="text-gray-400 text-xl">&times;</button>
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
              class="px-4 py-2 bg-gray-400 text-white rounded-lg font-semibold">
              Cancel</button>
            <button type="submit"
              class="px-4 py-2 bg-green-800 text-white rounded-lg font-semibold
                hover:bg-green-900">
              Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    {{-- ── DELETE MODAL ───────────────────────────────────────── --}}
    <div x-show="showDelete" x-transition style="display:none"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-orange-900 mb-3">Confirm Deletion</h3>
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
              class="px-4 py-2 bg-gray-400 text-white rounded-lg font-semibold">
              Cancel</button>
            <button type="submit"
              class="px-4 py-2 bg-orange-800 text-white rounded-lg font-semibold
                hover:bg-orange-900">
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
