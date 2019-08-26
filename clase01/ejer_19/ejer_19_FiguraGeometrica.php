abstract class
{
    private $_color;
    private $_perimetro;
    private $_superficie;

    public function __construct()
    {
        $this->_color = "black";
        $this->_perimetro = 0;
        $this->_superficie = 0;
    }

    public function GetColor()
    {
        return $this->_color;
    }

    public function SetColor($_color)
    {
        $this->_color = $_color;
    }

    public function ToString()
    {

        return ;
    }

    public abstract Dibujar();
    protected abstract CalcularDatos(); 
}