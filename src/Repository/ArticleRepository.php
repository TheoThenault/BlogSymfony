<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPublishedArticlesPaged($currentPage, $perPage): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('article');
        $queryBuilder->where('article.published = true');
        $queryBuilder->orderBy('article.createdAt', 'DESC');

        $query = $queryBuilder->getQuery();
        $query->setFirstResult(($currentPage - 1) * $perPage);
        $query->setMaxResults($perPage);
        return new Paginator($query);
    }

    public function findByCategorie($idCategorie): mixed
    {
        $querybuilder = $this->createQueryBuilder('article');
        $querybuilder->where('article.published = true');
        $querybuilder->leftJoin('article.categories', 'categorie');
        $querybuilder->addSelect('categorie');
        $querybuilder->andWhere('categorie.id = :id');
        $querybuilder->setParameter('id', $idCategorie);
        $querybuilder->orderBy('article.createdAt', 'DESC');

        return $querybuilder->getQuery()->getResult();
    }

    public function findByIDWithOrderedComments($articleID) : mixed
    {
        $queryBuilder = $this->createQueryBuilder('article');
        $queryBuilder->addSelect('article');
        $queryBuilder->where('article.id = :id');
        $queryBuilder->setParameter('id', $articleID);
        $queryBuilder->leftJoin('article.comments', 'comments');
        $queryBuilder->addSelect('comments');
        $queryBuilder->addOrderBy('comments.createdAt', 'DESC');

        if(is_null($queryBuilder->getQuery()->getResult()) || count($queryBuilder->getQuery()->getResult()) == 0)
        {
            return null;
        }
        return $queryBuilder->getQuery()->getResult()[0];
    }


//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
