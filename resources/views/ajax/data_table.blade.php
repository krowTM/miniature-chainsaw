<table>
    <tr>
        <th>Date</th>
        <th>Open</th>
        <th>High</th>
        <th>Low</th>
        <th>Close</th>
        <th>Volume</th>
        <th>Adj Close</th>
    </tr>
    @foreach ($data["valid_rows"] as $row)
     <tr>
        <td>{{ $row["Date"] }}</td>
        <td>{{ $row["Open"] }}</td>
        <td>{{ $row["High"] }}</td>
        <td>{{ $row["Low"] }}</td>
        <td>{{ $row["Close"] }}</td>
        <td>{{ $row["Volume"] }}</td>
        <td>{{ $row["Adj Close"] }}</td>
    </tr>    
    @endforeach
</table>

<div id="chart"></div>
<?= Lava::render('LineChart', 'Quotes', 'chart') ?>