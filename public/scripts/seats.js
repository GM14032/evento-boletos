const selectedTables = {
    "1-1": {
        selected: "1-1",
        selectedByMe: false,
    },
};

let rows = {};

const displaySeats = (seats) => {
    const seatsContainer = document.getElementById("ticket-position");
    if (!seatsContainer) return;
    rows = Object.entries(seats).reduce(
        (acc, [key, value]) => ({
            ...acc,
            [key]: value.map((data) => ({ ...data })),
        }),
        {}
    );
    const container = document.createElement("div");
    container.classList.add("seat-row");
    container.style.setProperty("--repeat-value", "3");
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
                    seat.innerText = numero;
                    if (
                        selectedTables[seat.id] &&
                        !selectedTables[seat.id].selectedByMe
                    ) {
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

const getPosition = (chairId = "") => {
    const [row, column] = chairId.split("-");
    if (!row || !column) {
        return {};
    }
    return {
        row,
        column,
    };
};

const selectTable = (table) => {
    const selected = document.getElementById(table);
    if (!selectedTables[table]) {
        const { column, row } = getPosition(table);
        if (!column || !row) {
            console.error("No se pudo obtener la posición");
            return;
        }
        const rowValue = rows[row];
        if (!rowValue) {
            console.error("No se pudo obtener la fila");
            return;
        }
        const columnValue = rowValue.find(
            (data) => data.numero === Number(column)
        );
        if (!columnValue) {
            console.error("No se pudo obtener la columna");
            return;
        }
        selectedTables[table] = {
            selected: table,
            item: columnValue,
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
