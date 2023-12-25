<?php

enum Type{
    case Select;
    case Delete;
    case Update;
    case Insert;
}

enum Table: string{
    case Blog = 'blog';
    case Comment = 'comment';
    case User = 'chess_user';
    case Image = 'blog_image';
    case Game = 'game';
}

enum Where: string{
    case BlogID = 'blog_id';
}

class QueryManager{
    private Type $type;
    private Table $table;
    private Where $column;
    private $parameterValue;

    public function __construct(Type $type, Table $table){
        $this->type = $type;
        $this->table = $table;
    }

    // need to add binding, not sure where to do the binding and execution try catch.
    public static function buildQuery($parameterValue, Type $type, Table $table, Where $column){
        $query = '';
        if($type === Type::Delete){
            $query = sprintf('DELETE FROM %s WHERE %s = %s', $table, $column, $parameterValue);
        }

        return $query;
    }

    public static function executeQuery(){
        
    }
}

?>