const selectedTables = {};

let indexedObj = {};

const displaySeats = ({ seats, maxSeats, indexed }) => {
    const seatsContainer = document.getElementById("ticket-position");
    if (!seatsContainer) return;
    indexedObj = indexed;
    // remove all div with children with the id "seats-container"
    seatsContainer.querySelectorAll("#seats-container").forEach((node) => {
        node.remove();
    });
    const container = document.createElement("div");
    container.id = "seats-container";
    container.classList.add("seat-row");
    container.style.setProperty("--repeat-value", `${maxSeats}`);
    // create a new div for each row
    Object.values(seats)
        .reverse()
        .forEach((value) => {
            // create a new div for each seat
            const seats = value.map(({ fila, numero, reservado }) => {
                const seat = document.createElement("div");
                if (fila) {
                    seat.id = `${fila}-${numero}`;
                    seat.setAttribute("data-seat", fila);
                    seat.setAttribute("data-reserved", reservado);
                    seat.innerText = "";
                    if (reservado) {
                        seat.classList.add("selected-other-user");
                    } else {
                        seat.classList.add("seat");
                        seat.addEventListener("click", () => {
                            selectTable(seat.id);
                        });
                    }
                }
                return seat;
            });
            seats.forEach((seat) => container.appendChild(seat));
        });
    seatsContainer.appendChild(container);
};

const selectTable = (table) => {
    const selected = document.getElementById(table);
    if (!selectedTables[table]) {
        const element = indexedObj[table];
        if (!element) {
            console.error("No se pudo obtener el eleemnto");
            return;
        }
        selectedTables[table] = {
            selected: table,
            item: element,
            selectedByMe: true,
        };
        selected.classList.add("selected");
        return;
    }
    if (selectedTables[table].selectedByMe) {
        selectedTables[table] = undefined;
        selected.classList.remove("selected");
        return;
    }
    console.error("Esta mesa ya fue seleccionada por otro usuario");
};

const saveElements = () => {
    const data = Object.keys(selectedTables).flatMap((key) => {
        if (selectedTables[key] && selectedTables[key].selectedByMe) {
            return selectedTables[key].item;
        }
        return [];
    });
    if (data.length === 0) {
        console.error("No hay mesas seleccionadas");
        return;
    }
    // estos son los datos, ya puedes enviarlos a la api y cambiar el estado a reservado
    console.log({ data });
};
