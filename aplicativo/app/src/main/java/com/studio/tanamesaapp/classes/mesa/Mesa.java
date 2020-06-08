package com.studio.tanamesaapp.classes.mesa;


public class Mesa {

    private int idMesa;
    private int numeroMesa;
    private int numLugaresMesa;

    public Mesa() {
    }

    public Mesa(int idMesa, int numeroMesa, int numLugaresMesa) {
        this.idMesa = idMesa;
        this.numeroMesa = numeroMesa;
        this.numLugaresMesa = numLugaresMesa;
    }

    public int getIdMesa() {
        return idMesa;
    }

    public void setIdMesa(int idMesa) {
        this.idMesa = idMesa;
    }

    public int getNumeroMesa() {
        return numeroMesa;
    }

    public void setNumeroMesa(int numeroMesa) {
        this.numeroMesa = numeroMesa;
    }

    public int getNumLugaresMesa() {
        return numLugaresMesa;
    }

    public void setNumLugaresMesa(int numLugaresMesa) {
        this.numLugaresMesa = numLugaresMesa;
    }
}
