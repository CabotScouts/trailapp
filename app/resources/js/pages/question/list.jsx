import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import Global from '@/layouts/global';
import ListFrame from '@/layouts/list-frame';
import ListItem from '@/components/list-item';

export default function QuestionList({ team, group, points, questions }) {
  return (
    <Global>
      <Head title="Questions" />
      <ListFrame team={team} group={group} points={points}>
        {questions.map(p => (<ListItem key={p.id} type="question" data={p} />))}
      </ListFrame>
    </Global>
  );
}
