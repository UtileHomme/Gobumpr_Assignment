<style type="text/css">

	table td, table th{

		border:1px solid black;

	}

</style>

<div class="container">


	<br/>

	<table>

		<tr>

			<th>Name</th>

			<th>Email Id</th>

		</tr>

		@foreach ($info as $a)

		<tr>

			<td>{{ $a->name }}</td>

			<td>{{ $a->email }}</td>

		</tr>

		@endforeach

	</table>

</div>
