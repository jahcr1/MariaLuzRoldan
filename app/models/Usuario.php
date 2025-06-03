<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

/**
 * Modelo Usuario
 * 
 * Gestiona la autenticación y administración de usuarios del panel administrativo
 */
class Usuario
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Autenticar usuario
     * 
     * @param string $email Email del usuario
     * @param string $password Contraseña sin hashear
     * @return array|false Datos del usuario o false si la autenticación falla
     */
    public function autenticar(string $email, string $password)
    {
        $sql = "SELECT id, nombre, email, password, rol, activo 
                FROM usuarios 
                WHERE email = :email AND activo = 1 
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            // Actualizar último acceso
            $this->actualizarUltimoAcceso($usuario['id']);
            
            // No devolver el hash de la contraseña
            unset($usuario['password']);
            return $usuario;
        }
        
        return false;
    }

    /**
     * Actualizar fecha de último acceso
     * 
     * @param int $id ID del usuario
     * @return bool Resultado de la operación
     */
    protected function actualizarUltimoAcceso(int $id): bool
    {
        $sql = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Obtener usuario por ID
     * 
     * @param int $id ID del usuario
     * @return array|false Datos del usuario o false si no existe
     */
    public function obtenerPorId(int $id)
    {
        $sql = "SELECT id, nombre, email, rol, activo, ultimo_acceso, created_at 
                FROM usuarios 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Listar todos los usuarios
     * 
     * @return array Lista de usuarios
     */
    public function listarTodos(): array
    {
        $sql = "SELECT id, nombre, email, rol, activo, ultimo_acceso, created_at 
                FROM usuarios 
                ORDER BY nombre ASC";
        
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crear nuevo usuario
     * 
     * @param array $datos Datos del usuario
     * @return int|false ID del usuario creado o false si falla
     */
    public function crear(array $datos)
    {
        // Verificar que el rol sea válido (admin/cliente)
        if (!in_array($datos['rol'], ['admin', 'cliente'])) {
            return false;
        }
        
        // Verificar si el email ya existe
        if ($this->emailExiste($datos['email'])) {
            return false;
        }
        
        $sql = "INSERT INTO usuarios (nombre, email, password, rol, activo) 
                VALUES (:nombre, :email, :password, :rol, :activo)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $datos['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($datos['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':rol', $datos['rol'], PDO::PARAM_STR);
        $stmt->bindValue(':activo', isset($datos['activo']) ? 1 : 0, PDO::PARAM_BOOL);
        
        if ($stmt->execute()) {
            return (int)$this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Actualizar usuario
     * 
     * @param int $id ID del usuario
     * @param array $datos Datos a actualizar
     * @return bool Resultado de la operación
     */
    public function actualizar(int $id, array $datos): bool
    {
        // Si cambia el email, verificar que no exista
        if (isset($datos['email']) && $this->emailExiste($datos['email'], $id)) {
            return false;
        }
        
        // Verificar que el rol sea válido (admin/cliente)
        if (isset($datos['rol']) && !in_array($datos['rol'], ['admin', 'cliente'])) {
            return false;
        }
        
        // Construir SQL dinámicamente según los campos proporcionados
        $campos = [];
        $params = [':id' => $id];
        
        if (isset($datos['nombre'])) {
            $campos[] = "nombre = :nombre";
            $params[':nombre'] = $datos['nombre'];
        }
        
        if (isset($datos['email'])) {
            $campos[] = "email = :email";
            $params[':email'] = $datos['email'];
        }
        
        if (!empty($datos['password'])) {
            $campos[] = "password = :password";
            $params[':password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        }
        
        if (isset($datos['rol'])) {
            $campos[] = "rol = :rol";
            $params[':rol'] = $datos['rol'];
        }
        
        if (isset($datos['activo'])) {
            $campos[] = "activo = :activo";
            $params[':activo'] = $datos['activo'] ? 1 : 0;
        }
        
        if (empty($campos)) {
            return true; // Nada que actualizar
        }
        
        $sql = "UPDATE usuarios SET " . implode(", ", $campos) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        return $stmt->execute();
    }

    /**
     * Eliminar usuario
     * 
     * @param int $id ID del usuario
     * @return bool Resultado de la operación
     */
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Verificar si un email ya existe
     * 
     * @param string $email Email a verificar
     * @param int|null $exceptId ID a exceptuar (para actualizaciones)
     * @return bool True si el email ya existe
     */
    protected function emailExiste(string $email, ?int $exceptId = null): bool
    {
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        
        if ($exceptId) {
            $sql .= " AND id != :id";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        
        if ($exceptId) {
            $stmt->bindValue(':id', $exceptId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return (bool)$stmt->fetch();
    }
    
    /**
     * Obtiene el total de administradores
     * 
     * @return int Número de administradores
     */
    public function obtenerTotalAdmins(): int
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE rol = 'admin'");
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en Usuario::obtenerTotalAdmins: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Verifica si existe al menos un administrador
     * 
     * @return bool True si existe al menos un administrador
     */
    public function existeAdmin(): bool
    {
        return $this->obtenerTotalAdmins() > 0;
    }
    
    /**
     * Obtiene el total de clientes
     * 
     * @return int Número de clientes
     */
    public function obtenerTotalClientes(): int
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuarios WHERE rol = 'cliente'");
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en Usuario::obtenerTotalClientes: " . $e->getMessage());
            return 0;
        }
    }
}
