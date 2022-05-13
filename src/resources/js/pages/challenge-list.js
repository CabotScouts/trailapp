import React from 'react';
import { Head, useForm } from '@inertiajs/inertia-react';
import ListFrame from '@/layouts/list-frame';
import ChallengeListItem from '@/components/challenge-list-item';

export default function ChallengeList({ team, group, challenges }) {
  return (
    <>
      <Head title="Challenges" />
      <ListFrame team={ team } group={ group }>
        { challenges.map(p => (<ChallengeListItem key={ p.id } data={ p } />)) }
      </ListFrame>
    </>
  );
}
