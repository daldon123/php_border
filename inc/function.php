<!doctype html>

<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <style>
    #boardContainer {
        display: flex;
        flex-direction: column;
    }

    h1,
    td {
        text-align: center;
    }

    tr>*:nth-child(1) {
        width: 2rem;
    }

    tr>*:nth-child(2) {
        width: 8rem;
    }

    tr>*:nth-child(3) {
        width: 4rem;
    }

    button {
        width: fit-content;
        margin-left: auto;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
    </style>
</head>


<body>

    <div id="boardContainer">
        <h1>게시판</h1>
        <button>글쓰기</button>
        <table>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>글쓴이</th>
                </tr>
            </thead>
            	<tbody id="tableBody">
            </tbody>
        </table>

    </div>

    <?php

    // mysqli_connect 인자값 ( DB 접속 주소, DB 접속 유저명, 유저 비밀번호, 디비명 )
    $conn = mysqli_connect("192.168.0.251", "domebon_mall", "vmfk##77", "hong");

    // "board" 테이블의 모든 값을 요청
    $query = "select * from table01";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $boardDatas[] = $row;
    }

    mysqli_close($conn);
    ?>

    <script>
    const boardDatas = <?php echo json_encode($boardDatas) ?>

    console.log(boardDatas);


    const tablebodyElement = document.getElementById('tableBody');

    const dataLenght = boardDatas.length;
    for (let i = 0; i < dataLenght; i++) {
        const itrData = boardDatas[i];

        const tr = document.createElement('tr');

        const idTd = document.createElement('td');
        idTd.innerHTML = itrData.id;
        tr.appendChild(idTd);

        const titleTd = document.createElement('td');
        titleTd.innerHTML = itrData.title;
        tr.appendChild(titleTd);

        const nicknameTd = document.createElement('td');
        nicknameTd.innerHTML = itrData.nickname;
        tr.appendChild(nicknameTd);

        tablebodyElement.appendChild(tr);
    }
    </script>

</body>

</html>

