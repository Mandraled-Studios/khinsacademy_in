<x-admin-layout>
    <x-slot name="title">
        Assign Quiz to Department
    </x-slot>
    <div class="container py-6">
        <h2 class = "text-xl font-bold mb-6"> Assigned to following departments: </h2>
        <?php $avoid = array(); ?>
        @foreach ($relations as $relation)
            <div class="flex border border-gray-400 p-3 mb-4 justify-between"> 
                <div class = "flex items-center">
                    <img class = "w-16 h-16 mr-3" src="{{$relation->icon}}" alt="exam-icon">
                    <h3 class = "text-lg font-bold"> {{$relation->title}} </h3>
                </div>
                <form action="{{route('admin.quiz.deassign', ['dept' => $relation->department_id, 'quiz' => $relation->quiz_id ])}}" method = "POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class = "text-lg font-semibold bg-red-500 text-white p-3" value = "x" >
                </form>
            </div>
            <?php array_push($avoid, $relation->department_id); ?>
        @endforeach
    
        <form action="{{route('admin.quiz.assign', ['id' => $quiz->id])}}" class = "mt-12" method="POST">
            @csrf
            <h2 class = "text-xl font-bold mb-6"> Assign Exam to: </h2>
            <select name="addDept" id="addDept">
                @foreach ($departments as $department)
                    @if(array_search($department->id, $avoid) === false)
                        <option value = "{{$department->id}}"> {{$department->title}} </option>
                    @endif
                @endforeach
            </select>
            <input class = "px-4 py-2 bg-orange-400" type="submit" value="Add Exam To Department">
        </form>
        
    </div>
</x-admin-layout>