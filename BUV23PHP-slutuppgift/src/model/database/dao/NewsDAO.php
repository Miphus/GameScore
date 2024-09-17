<?php
class NewsDAO {

    private PDO $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insertNews(News $news): void {
        $stmt = $this->pdo->prepare("INSERT INTO news (title, author, publishDate, content, image, url, source, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$news->getTitle(), $news->getAuthor(), $news->getPublishDate(), $news->getContent(), $news->getImage(), $news->getUrl(), $news->getSource(), $news->getAddress()]);
    }
    
    
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM news");
        $newsList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $news = new News();
            $news->setTitle($row['title']);
            $news->setAuthor($row['author']);
            $news->setPublishDate($row['publishDate']);
            $news->setContent($row['content']);
            $news->setImage($row['image']);
            $news->setUrl($row['url']);
            $news->setSource($row['source']);
            $news->setAddress($row['address']);
            $newsList[] = $news;
        }
        return $newsList;
    }

    public function findById(int $id): News
    {
        $stmt = $this->pdo->prepare("SELECT * FROM news WHERE id= :id limit 1 ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
       
       return $stmt->fetchAll(PDO::FETCH_CLASS, News::class)[0];
            
        
        
       
    }
    
    

}
?>
