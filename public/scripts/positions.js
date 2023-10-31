const createIndexedObject = (seats) => {
    const simpleGraph = seats.reduce((acc, data) => {
        return {
            ...acc,
            [`${data.fila}-${data.numero}`]: data,
        };
    }, {});
    return simpleGraph;
};

const getZone = async (idEvent, idZone, fillRight = false) => {
    const response = await fetch(`/asiento-evento/${idEvent}/${idZone}`);
    /**
     * fila: 1
     * id: 1
     * id_evento_zona: 1
     * id_zona: 1
     * numero: 1
     * reservado: 0
     */
    const data = await response.json();
    const indexed = createIndexedObject(data);
    // reduce with the follow format { [fila]: [{id, numero, reservado }]}
    const seats = data.reduce((acc, { fila, id, numero, reservado }) => {
        if (!acc[fila]) {
            return { ...acc, [fila]: [{ id, fila, numero, reservado }] };
        }
        return {
            ...acc,
            [fila]: [...acc[fila], { id, fila, numero, reservado }],
        };
    }, {});
    // get the max number of seats per row
    const maxSeats = Object.values(seats).reduce(
        (acc, { length }) => (length > acc ? length : acc),
        0
    );
    // fill the empty seats
    const seatsFilled = Object.entries(seats).reduce((acc, [key, value]) => {
        if (fillRight) {
            return {
                ...acc,
                [key]: [
                    ...value,
                    ...Array.from(
                        { length: maxSeats - value.length },
                        () => ({})
                    ),
                ],
            };
        }
        return {
            ...acc,
            [key]: [
                ...Array.from({ length: maxSeats - value.length }, () => ({})),
                ...value,
            ],
        };
    }, {});
    return { seats: seatsFilled, maxSeats, indexed };
};
