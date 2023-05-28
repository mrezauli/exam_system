<!DOCTYPE html>
<html>

<head>
    <title>Counter</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <div id="app" class="container-fluid">
        <div class="row">
            <div class="col mt-3">
                <h1>Question:</h1>
                <p id="question" class="fs-1 text-sm">ঘটনা শুধু কুমিল্লায়ই সীমাবদ্ধ ছিল না, চাঁদপুর, নোয়াখালী, লক্ষ্মীপুর, চট্টগ্রাম, বান্দরবান, ফেনী, গাজীপুর, কুড়িগ্রাম, চাঁপাইনবাবগঞ্জ, মৌলভীবাজার, কক্সবাজার, মুন্সীগঞ্জ, হবিগঞ্জ, বরিশালে মন্দির- মণ্ডপে হামলা হয়, ভাংচুর করা হয়, আগুন দেওয়া হয় হিন্দুদের বাড়ি ও দোকানপাটে।
                </p>
                <hr class="border border-primary border-1 opacity-75">
                <h1>Answer:</h1>
                <p id="answer" class="fs-1 text-sm">ঘটনা শুধু কুমিল্লায়ই সীমাবদ্ধ ছি না, চাঁদপুর, নোয়াখালী, লক্ষ্মীপুর, চট্টগ্রাম, বান্দবান, ফেনী, গাজীপুর, কুড়িগ্রাম, চাঁপাইনবাবগঞ্জ, মৌলভীবজার, কক্সবাজার, মুন্সীগঞ্জ, হবিগঞ্জ,</p>
                <hr class="border border-primary border-1 opacity-75">
                <h1>Diff Text:</h1>
                <p id="display" class="fs-1 text-sm"></p>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2" class="text-center table-info">Parameter</th>
                            <th rowspan="2" class="align-middle table-info">Value</th>
                        </tr>
                        <tr>
                            <th>Wordwise</th>
                            <th>Characterwise</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr>
                            <th scope="row" class="text-primary">Given Words</th>
                            <td>---</td>
                            <td id="gw" class="text-primary "></td>
                        </tr>
                        <tr>
                            <td>---</td>
                            <th scope="row" class="text-primary">Given Characters (With Space)</th>
                            <td id="gcws" class="text-primary "></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-warning">Typed Words</th>
                            <td>---</td>
                            <td id="tw" class="text-warning "></td>
                        </tr>
                        <tr>
                            <td>---</td>
                            <th scope="row" class="text-warning">Typed Characters (With Space)</th>
                            <td id="tcws" class="text-warning "></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-success">Corrected Words</th>
                            <td>---</td>
                            <td id="cw" class="text-success "></td>
                        </tr>
                        <tr>
                            <td>---</td>
                            <th scope="row" class="text-success">Corrected Characters (With Space)</th>
                            <td id="ccws" class="text-success "></td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-danger">Wrong Words</th>
                            <td>---</td>
                            <td id="ww" class="text-danger "></td>
                        </tr>
                        <tr>
                            <td>---</td>
                            <th scope="row" class="text-danger">Wrong Characters (With Space)</th>
                            <td id="wcws" class="text-danger "></td>
                        </tr>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="{{ URL::asset('assets/dist/diff.js') }}"></script>
    <script>
        const question = document.getElementById("question").textContent.trim(),
            answer = document.getElementById("answer").textContent.trim();

        const chracterizedQuestionWithSpaceFromQuestion = [...question].join(""),
            chracterizedAnswerWithSpaceFromAnswer = [...answer].join("");
        const chracterizedQuestionWithSpaceComma = [...question].join(","),
            chracterizedAnswerWithSpaceComma = [...answer].join(",");

        //document.getElementById("gw").textContent = question.length / 5;
        document.getElementById("gw").textContent = question.split(' ').length;
        document.getElementById("gcws").textContent =
            chracterizedQuestionWithSpaceFromQuestion.length;
        // const tw = (document.getElementById("tw").textContent =
        //     answer.length / 5);
            const tw = (document.getElementById("tw").textContent =
            answer.split(' ').length);
        const tcws = (document.getElementById("tcws").textContent =
            chracterizedAnswerWithSpaceFromAnswer.length);

        let span = null,
            correctedCharacterCount = null;

        const diffWithSpaceComma = Diff.diffChars(
                chracterizedQuestionWithSpaceComma,
                chracterizedAnswerWithSpaceComma
            ),
            diffFromOriginal = Diff.diffChars(
                chracterizedQuestionWithSpaceFromQuestion,
                chracterizedAnswerWithSpaceFromAnswer
            ),
            display = document.getElementById("display"),
            fragment = document.createDocumentFragment();
        // console.log(chracterizedQuestionWithSpaceFromQuestion);
        // console.log(chracterizedQuestionWithSpaceComma);
        // console.log(chracterizedAnswerWithSpaceFromAnswer);
        // console.log(chracterizedAnswerWithSpaceComma);

        diffWithSpaceComma.forEach((part) => {
            // green for additions, red for deletions
            // grey for common parts
            const color = part.added ? "white" : part.removed ? "white" : "black";
            const backgroundColor = part.added ? "orange" : part.removed ? "red" : "grey";
            console.log(part);
            //console.log(typeof(part.added));
            //console.log(typeof(part.removed));

            if (part.added === undefined && part.removed === undefined) {
                //console.log(part);
                correctedCharacterCount += part.count;
            }

            span = document.createElement("span");
            span.style.color = color;
            span.style.backgroundColor = backgroundColor;
            span.appendChild(document.createTextNode(part.value));
            fragment.appendChild(span);
        });

        correctedCharacterCount = Math.floor(correctedCharacterCount /= 2);

        display.appendChild(fragment);

        document.getElementById("ccws").textContent = correctedCharacterCount;
        document.getElementById("wcws").textContent = tcws - correctedCharacterCount;
        document.getElementById("cw").textContent = correctedCharacterCount / 5;
        document.getElementById("ww").textContent = (tcws - correctedCharacterCount) / 5;
    </script>
</body>

</html>
